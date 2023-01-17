(async () => {
    const matchInfo = {
        'Arsenal': 0,
        'Manchester United': 1,
        id: 0,
    }
    Array.from(document.getElementsByClassName('imso_gf__gf-itm')).filter((item) => {
        if (item.getElementsByClassName('imso_gf__sub-cs1 imso_gf__in-card-yld').length > 0) return true;
    }).map((item) => {
        return {
            team: item.getElementsByClassName('imso_gf__pl-info')[0].innerText.split(' · ')[0],
            in: item.getElementsByClassName('imso_gf__pl-info')[0].innerText.split(' · ').at(-1).split(' ').at(-1).replace('#', ''),
            out: item.getElementsByClassName('imso_gf__pl-info')[1].innerText.split(' · ').at(-1).split(' ').at(-1).replace('#', '')
        }
    })
})();
