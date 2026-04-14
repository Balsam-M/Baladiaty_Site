// ==== المودال ====
const modal = document.getElementById('loginModal');
const closeBtn = modal.querySelector('.close');

const loginIcon = document.getElementById("openAccountModal");
if(loginIcon){
    loginIcon.addEventListener("click", (e) => {
        e.preventDefault();
        modal.style.display = "flex";
    });
}

// فتح المودال عند الضغط على أي زر "مزيد من التفاصيل"
document.querySelectorAll('.learn-more-btn').forEach(btn => {
    btn.addEventListener('click', (e) => {
        e.preventDefault(); // منع href من التحرك
        modal.style.display = 'flex'; // فتح المودال
    });
});

// غلق المودال عند الضغط على ×
closeBtn.addEventListener('click', () => {
    modal.style.display = 'none';
});

// غلق المودال عند الضغط خارج المحتوى
window.addEventListener('click', (e) => {
    if(e.target === modal){
        modal.style.display = 'none';
    }
});
// التحقق إذا جاي من signup
window.addEventListener("load", () => {
    const params = new URLSearchParams(window.location.search);
    if (params.get("openLogin") === "true") {
        modal.style.display = "flex"; // يفتح المودال بالنص
    }
});





const togglePassword = document.querySelector('.toggle-password');
const password = document.getElementById('password');
const eyeOpen = togglePassword.querySelector('.open');
const eyeClosed = togglePassword.querySelector('.closed');

togglePassword.addEventListener('click', () => {
    const type = password.getAttribute('type') === 'password' ? 'text' : 'password';
    password.setAttribute('type', type);

    // تبديل ظهور العين المفتوحة والمغلقة
    if(type === 'password') {
        eyeOpen.style.display = 'block';
        eyeClosed.style.display = 'none';
    } else {
        eyeOpen.style.display = 'none';
        eyeClosed.style.display = 'block';
    }
});

