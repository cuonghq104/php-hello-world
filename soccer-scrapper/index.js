const puppeteer = require('puppeteer');
const fs = require('fs');
const _ = require('lodash');
const moment = require('moment');

const POSITION_LIST = {
    "Goalkeeper": "GK",
    "Centre-Back": "CB",
    "Left-Back": "LB",
    "Right-Back": "RB",
    "Defensive Midfield": "DM",
    "Central Midfield": "CM",
    "Right Midfield": "RM",
    "Left Midfield": "LM",
    "Attacking Midfield": "AM",
    "Left Winger": "LW",
    "Right Winger": "RW",
    "Second Striker": "SS",
    "Centre-Forward": "CF"
};
(async () => {
    const browser = await puppeteer.launch({ headless: true });
    const page = await browser.newPage();
    await page.exposeFunction('formatDate', (date) =>
        moment(date, 'MMM DD, YYYY').format('YYYY-MM-DD')
    );

    await page.exposeFunction('capitalize', (name) =>
        _.capitalize(name)
    );
    await page.goto('https://www.transfermarkt.com/manchester-united/startseite/verein/985');
    let results = await page.evaluate(() => {
        return Array.from(
            document
                .querySelectorAll('span.hide-for-small'))
            .filter(a => a.className = 'hide-for-small')
            .map(a => a.childNodes[0].href).filter(a => !a.includes('startseite') && !a.includes('kadernaechstesaison'));
    });

    const crawlResults = [];
    for (const [index, url] of results.entries()) {
        console.log('Index::', index, url);
        await page.goto(url);
        const res = await page.evaluate(async () => {
            const nameContainer = Array.from(document.getElementsByClassName('data-header__headline-wrapper'))[0].innerText;
            const [squadNumber, name] = nameContainer.split(/ (.*)/s);

            const labelArray = Array.from(document.getElementsByClassName('info-table__content info-table__content--regular')).map(t => t.innerText);
            const dateOfBirthIndex = labelArray.findIndex((t) => t === 'Date of birth:');
            const positionIndex = labelArray.findIndex((t) => t === 'Position:');
            const nationalityIndex = labelArray.findIndex((t) => t === 'Citizenship:');

            const infoContainer = Array.from(document.getElementsByClassName('info-table__content info-table__content--bold'));
            const position = infoContainer[positionIndex].innerText.trim();
            const positionName = position === 'Goalkeeper' ? 'Goalkeeper' : position.split(' - ')[0];
            const positionDetail = position === 'Goalkeeper' ? 'GK' : position.split(' - ')[1].replace(' ', '-').split('-').map((t) => t[0]).join('')

            const dateOfBirth = infoContainer[dateOfBirthIndex].innerText.trim();
            const dob = await window.formatDate(dateOfBirth);
            const pos = await window.capitalize(positionName);

            return {
                squad_number: parseInt(squadNumber.replace('#', '')),
                name: name.normalize("NFD").replace(/\p{Diacritic}/gu, ""),
                nationality: infoContainer[nationalityIndex].innerText.trim().split('\n')[0],
                date_of_birth: dob,
                position: pos,
                detail_position: positionDetail,
                id_team: 5
            }
        })
        crawlResults.push(res);
    }
    fs.writeFile('MU.json', JSON.stringify(crawlResults), (err) => {
        // In case of a error throw err.
        if (err) throw err;
    })
    console.log('crawlResults', crawlResults);

    await page.close();
    await browser.close();
})();

