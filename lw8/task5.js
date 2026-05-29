function userName(users) {
    if (Array.isArray(users)) {
        let userNames = users.map(user => user?.name || "Неизвестно");
        return userNames;
    } else {
        console.log('Параметр должен быть массивом');
        return [];
    }
}