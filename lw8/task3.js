function uniqueElements(array) {
    let obj = {};

    for (let value of array) {
        let str = String(value);
        obj[str] = (obj[str] || 0) + 1;
    }

    return obj;
}