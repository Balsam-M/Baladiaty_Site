document.addEventListener("DOMContentLoaded", () => {

    const loginModal = document.getElementById('loginModal');
    const loginBtn = document.getElementById('login-btn');
    const idInput = document.getElementById('login-id');
    const passwordInput = document.getElementById('login-password');
    const errorMsg = document.getElementById('login-error');

    const openModalBtn = document.getElementById('openAccountModal');
    const closeBtn = loginModal.querySelector('.close');
    const togglePassword = loginModal.querySelector('.toggle-password');
    const eyeOpen = togglePassword.querySelector('.eye-icon.open');
    const eyeClosed = togglePassword.querySelector('.eye-icon.closed');

    // فتح المودال
    openModalBtn.addEventListener('click', () => {
        loginModal.style.display = 'flex'; // يظهر المودال مع تمركزه
    });

    closeBtn.addEventListener('click', () => {
        loginModal.style.display = 'none'; // يغلق المودال
    });



    // إظهار/إخفاء كلمة المرور
    togglePassword.addEventListener('click', () => {
        if(passwordInput.type === 'password'){
            passwordInput.type = 'text';
            eyeOpen.style.display = 'none';
            eyeClosed.style.display = 'inline';
        } else {
            passwordInput.type = 'password';
            eyeOpen.style.display = 'inline';
            eyeClosed.style.display = 'none';
        }
    });

    // تسجيل الدخول
    loginBtn.addEventListener('click', () => {
        const id = idInput.value.trim();
        const password = passwordInput.value.trim();

        if(!id || !password){
            errorMsg.textContent = "يرجى ملء جميع الحقول!";
            errorMsg.style.display = 'block';
            return;
        }

        fetch('adminphp/login.php', {
            method: 'POST',
            headers: {'Content-Type': 'application/x-www-form-urlencoded'},
            body: `id=${encodeURIComponent(id)}&password=${encodeURIComponent(password)}`
        })
            .then(res => res.text())
            .then(data => {
                console.log(data);
                const json = JSON.parse(data);

                if(json.status === "success"){

                    if(json.role === "admin"){
                        window.location.href = "http://localhost/webproject/admin.html";
                    } else {
                        window.location.href = "adminphp/userpage.php";
                    }

                } else {
                    errorMsg.textContent = json.message;
                    errorMsg.style.display = "block";
                }
            })


            .catch(err => {
                errorMsg.textContent = "حدث خطأ، حاول مرة أخرى";
                errorMsg.style.display = 'block';
            });
    });

});