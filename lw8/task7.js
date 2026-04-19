const minLenghtOfPassword = 4;

function generatePassword(length) {
    if (length < minLenghtOfPassword) {
        console.log('Длина пароля должна быть не менее' ,minLenghtOfPassword, 'символов для обеспечения безопасности.');
        return;
    }

    const lowercaseChars = 'abcdefghijklmnopqrstuvwxyz';
    const uppercaseChars = 'ABCDEFGHIJKLMNOPQRSTUVWXYZ';
    const digitChars = '0123456789';
    const specialChars = '!@#$%^&*()_+-=[]{}|;:,.<>?';
    const allChars = lowercaseChars + uppercaseChars + digitChars + specialChars;

    let passwordArray = [];
    passwordArray.push(lowercaseChars[Math.floor(Math.random() * lowercaseChars.length)]);
    passwordArray.push(uppercaseChars[Math.floor(Math.random() * uppercaseChars.length)]);
    passwordArray.push(digitChars[Math.floor(Math.random() * digitChars.length)]);
    passwordArray.push(specialChars[Math.floor(Math.random() * specialChars.length)]);
  
    const remainingLength = length - passwordArray.length;
    for (let i = 0; i < remainingLength; i++) {
        passwordArray.push(allChars[Math.floor(Math.random() * allChars.length)]);
    }

    for (let i = passwordArray.length - 1; i > 0; i--) {
        const j = Math.floor(Math.random() * i);
        [passwordArray[i], passwordArray[j]] = [passwordArray[j], passwordArray[i]];
    }

    return passwordArray.join('');
}