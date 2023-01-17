const puppeteer = require('puppeteer');
const fs = require('fs');
(async () => {
    console.log('start');
    const browser = await puppeteer.launch({ headless: true });
    const page = await browser.newPage();
    await page.goto('https://www.transfermarkt.com/spielbericht/index/spielbericht/3837977');
    let results = await page.evaluate(() => {
        const starting = (index) => Array.from(document.getElementsByClassName('large-6 columns')[index].children[2].children[1].children)
            .filter((v) => v.className === 'aufstellung-spieler-container').map((item) => ({number: Number.parseFloat(item.children[0].innerText) }));
        const substitution = (index) => Array.from(document.getElementsByClassName('large-6 columns')[index].children[3].children[0].children[0].children)
            .map((item) => ({number: item.children[0].innerText, position: item.children[2].innerText}))
            .filter((item) => item.number !== 'Manager:')
            .map(item => ({number: Number.parseInt(item.number), position: item.position}))

        return {
            home: {
                starting: starting(0),
                substitution: substitution(0)
            },
            away: {
                starting: starting(1),
                substitution: substitution(1)
            }
        };
    });

    console.log(JSON.stringify(results));
    await page.close();
    await browser.close();
})();
