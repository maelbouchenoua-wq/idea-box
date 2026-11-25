ocument.querySelectorAll('.btn-vote').forEach(button => {

    button.addEventListener('click', async () => {

        const infoId = button.dataset.infoId;

        const counter = button.querySelector('.btn-vote__nb');

        button.disabled = true;

        const formData = new FormData();

        formData.append('info_id', infoId);
        formData.append('csrf_token', csrfToken);

        try {

            const response = await fetch('vote.php', {
                method: 'POST',
                body: formData
            });

            const data = await response.json();

            if (data.nbVote !== undefined) {
                counter.textContent = data.nbVote;
            }

            if (data.success) {

                button.classList.add('voted');

            } else {

                alert(data.message);

                if (response.status === 401 ||
                    data.message.includes('déjà voté')) {
                    button.classList.add('voted');
                } else {
                    button.disabled = false;
                }

            }

        } catch (error) {

            alert('Erreur lors du vote.');
            button.disabled = false;

        }

    });

});