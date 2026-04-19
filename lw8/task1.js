function isPrimeNumber(n) {
    if (Array.isArray(n)) {
        for (let value of n){
            isPrimeNumber(value);
        }  
    }
    else if (typeof(n) === 'number') {
        let isPrime = false;
        if (n > 1 && n % 1 === 0) {
            isPrime = true;
            for (let k = 2; k < n; k++) {
                if (n % k == 0) {
                    isPrime = false;
                    break;
                }
            }
        }
        console.log('Результат:', n, isPrime ? 'простое число' : 'не простое число');
    }
    else {
        console.log('Переданный параметр', n ,'не является массивом или числом');   
    }
}