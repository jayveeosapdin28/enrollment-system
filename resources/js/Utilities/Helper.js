function getSem(sem) {
    if (sem === 1 || sem === '1')
        return 'FIRST'
    if (sem === 2 || sem === '2')
        return 'SECOND'
    if (sem === 3 || sem === '3')
        return 'SUMMER'
};

function getYearLevel(year) {
    if (year === 1 || year === '1')
        return 'FIRST'
    if (year === 2 || year === '2')
        return 'SECOND'
    if (year === 3 || year === '3')
        return 'THIRD'
    if (year === 4 || year === '4')
        return 'FOURTH'
    if (year === 5 || year === '5')
        return 'FIFTH'
};

function yearlevels(){
    return [
        { value: '1', text: 'FIRST YEAR'},
        { value: '2', text: 'SECOND YEAR'},
        { value: '3', text: 'THIRD YEAR'},
        { value: '4', text: 'FOURTH YEAR'},
        { value: '5', text: 'FIFTH YEAR'},
    ]
}

function campuses(){
    return [
        { id: 'MMC', text: 'MAIN CAMPUS (ALCATE, VICTORIA)'},
        // { id: 'MCC', text: 'CALAPAN CAMPUS (MASIPIT, CAPALAN CITY)'},
        // { id: 'MBC', text: 'BONGABONG CAMPUS (LABASAN, BONGABONG)'}
    ]
}

function semesters(){
    return [
        { id: '1', text: 'FIRST SEMESTER'},
        { id: '2', text: 'SECOND SEMESTER'},
        { id: '3', text: 'SUMMER'}
    ]
}
function toTitleCase (str){
    return str
        .toLowerCase()
        .split(' ')
        .map(word => word.charAt(0).toUpperCase() + word.slice(1))
        .join(' ');
}
function formatPrice(value) {
    let val = (value / 1).toFixed(2).replace(',', '.')
    return val.toString().replace(/\B(?=(\d{3})+(?!\d))/g, ",")
}

export {
    getYearLevel,
    getSem,
    semesters,
    yearlevels,
    campuses,
    toTitleCase,
    formatPrice,
}
