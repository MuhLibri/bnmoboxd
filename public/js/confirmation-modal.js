function handleConfirm(e, callback, modalId) {
    e.preventDefault();
    alert(e)
    handleClose(modalId);
    eval(callback + '()');
}

function handleClose(modalId) {
    const modal = document.querySelector(modalId);
    modal.classList.remove('active');
}

function handleOpen(modalId) {
    const modal = document.querySelector(modalId);
    modal.classList.add('active');
}