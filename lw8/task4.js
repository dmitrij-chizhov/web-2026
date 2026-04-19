function mergeObjects(obj1, obj2) {
    let resObj = {};

    for (let key in obj1) {
        resObj[key] = obj1[key];    
    }
    for (let key in obj2) {
        resObj[key] = obj2[key];
    }

    return resObj;
}