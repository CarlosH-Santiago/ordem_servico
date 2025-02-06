document.getElementById("cadastroForm").addEventListener("submit", function(event) {
    const senha = document.getElementById("cadSenha").value;
    const senhaConf = document.getElementById("cadSenhaConf").value;
    const errorMessage = document.getElementById("errorMessage");

    if (senha !== senhaConf) {
        event.preventDefault(); // Impede o envio do formulário
        errorMessage.textContent = "As senhas não coincidem!";
    } else {
        errorMessage.textContent = "";
    }
});