function mapFilter(n) {
    if (Array.isArray(n)) {
        let result = n.map(x => x * 3).filter(x => x > 10);
        return result;
    } else {
        console.log("Параметр должен быть массивом");
        return [];
    }
}