function showPassword() {
    var inputPass = document.getElementById('senha')
    var btnShowPass = document.getElementById('btn-showPass')


    if(inputPass.type === 'password') {
        inputPass.setAttribute('type', 'text')
        btnShowPass.classList.replace('bi-eye', 'bi-eye-slash')
    } else {
        inputPass.setAttribute('type', 'password')
        btnShowPass.classList.replace('bi-eye-slash', 'bi-eye')
    }

}

function showPassConfirm() {
    var inputConfirmPass = document.getElementById('senhaConf')
    var btnShowPassConfirm = document.getElementById('btn-showPassConfirm')



    if(inputConfirmPass.type === 'password') {
        inputConfirmPass.setAttribute('type', 'text')
        btnShowPassConfirm.classList.replace('bi-eye', 'bi-eye-slash')
    } else {
        inputConfirmPass.setAttribute('type', 'password')
        btnShowPassConfirm.classList.replace('bi-eye-slash', 'bi-eye')
    }
}
