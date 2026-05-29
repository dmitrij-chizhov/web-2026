function uniqueElements(array) {
    if (Array.isArray(array)) {
        let obj = {};

        for (let value of array) {
            let str = String(value);
            obj[str] = (obj[str] || 0) + 1;
        }

        return obj;
    } else {
        console.log('Переданный параметр ', array ,' не является массивом');
        return {};
    }
}