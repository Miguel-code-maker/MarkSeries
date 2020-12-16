const checks = document.querySelectorAll('[type="checkbox"]');
const checkPersonaliza = document.querySelector('#checkPersonaliza')
const linkInput = document.querySelector('#link')
const divPersonaliza = document.querySelector('.col-link');
checkPersonaliza.checked = false;
checks.forEach(check => {
    check.addEventListener('click', e => {
        checks.forEach(c => {
            c.checked = (c == e.target);
            if (c.checked && c == checkPersonaliza) {
                divPersonaliza.style = "display: block;";
            } else {
                divPersonaliza.style = "display: none;"
                linkInput.value = '';
            }

        })
    })
})
