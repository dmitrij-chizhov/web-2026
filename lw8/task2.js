function countVowels(str) {
    const vowels = ['а', 'е', 'ё', 'и', 'о', 'у', 'ы', 'э', 'ю', 'я'];
    let vowelsStr = '';
    let count = 0;  
    str = str.toLowerCase();
    for (let ch of str) {
        for (let chV of vowels) {
            if (ch === chV) {
                count++;
                if (count > 1) {
                    vowelsStr += ', ';
                }
                vowelsStr += ch;
                
            }
        }
    }

    let result = count + ' (' + vowelsStr + ')'
    return result;
}