function mergeObjects(obj1, obj2) {
    
    if (typeof obj1 !== 'object' || obj1 === null || Array.isArray(obj1)) {
        console.log('Первый параметр должен быть объектом');
        return {};
    }
    if (typeof obj2 !== 'object' || obj2 === null || Array.isArray(obj2)) {
        console.log('Второй параметр должен быть объектом');
        return {};
    }

    let resObj = {};

    for (let key in obj1) {
        resObj[key] = obj1[key];    
    }
    for (let key in obj2) {
        resObj[key] = obj2[key];
    }

    return resObj;
}