let updatesbtn = document.querySelectorAll('.update')

updatesbtn.forEach(update => {
    update.onclick = () => {
        update.nextElementSibling.style.display = "inline-block",
        update.style.display = "none"
        update.closest('.row').querySelectorAll('input').forEach(input => {
            input.removeAttribute('readonly')
        })
    }
})