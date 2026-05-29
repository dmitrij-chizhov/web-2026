function mapObject(obj, callback) {
    if (typeof obj !== 'object' || obj === null || Array.isArray(obj)) {
        console.log('Первый параметр должен быть объектом');
        return {};
    }
    if (typeof callback !== 'function') {
        console.log('Второй параметр должен быть функцией');
        return {};
    }

    let newObj = {};
    for (let key in obj) {
        newObj[key] = callback(obj[key]);
    }
    return newObj;
}