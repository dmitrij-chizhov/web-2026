function mapObject(obj, callback) {
    let newObj = {};
    for (let key in obj) {
        newObj[key] = callback(obj[key]);
    }
    return newObj;
}