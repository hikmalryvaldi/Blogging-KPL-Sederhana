'use strict';

const login = document.querySelector('.login');
const captcha = document.querySelector('.captcha');

login.addEventListener('click', function (e) {
  const respon = grecaptcha.getResponse();
  // alert(captcha);

  if (respon.length === 0) {
    e.preventDefault();
    captcha.innerHTML = 'Verifikasi bahwa anda bukan robot';
  }
});
