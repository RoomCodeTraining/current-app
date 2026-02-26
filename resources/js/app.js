import './bootstrap';

window.addEventListener('DOMContentLoaded', () => {
    // Gestion de la zone photo / avatar
    const avatarInput = document.getElementById('avatar');
    const avatarPreview = document.getElementById('avatar-preview');
    const avatarInfo = document.getElementById('avatar-selected-info');
    const avatarDropzone = document.getElementById('avatar-dropzone');

    if (avatarInput && avatarPreview && avatarInfo && avatarDropzone) {
        avatarInput.addEventListener('change', function () {
            const file = this.files && this.files[0];
            if (!file) {
                avatarPreview.classList.add('hidden');
                avatarInfo.classList.add('hidden');
                avatarInfo.textContent = '';
                avatarDropzone.classList.remove('border-green-500');
                return;
            }

            avatarInfo.textContent = 'Photo sélectionnée : ' + file.name;
            avatarInfo.classList.remove('hidden');
            avatarDropzone.classList.add('border-green-500');

            if (file.type && file.type.indexOf('image') === 0 && window.FileReader) {
                const reader = new FileReader();
                reader.onload = function (e) {
                    avatarPreview.src = e.target.result;
                    avatarPreview.classList.remove('hidden');
                };
                reader.readAsDataURL(file);
            } else {
                avatarPreview.classList.add('hidden');
            }
        });
    }
});
