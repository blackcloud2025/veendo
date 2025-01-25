     
    document.querySelectorAll('[data-type]').forEach(button => {
        button.addEventListener('click', function() {
            document.getElementById('selected_banner_type').value = this.dataset.type;
        });
    });





