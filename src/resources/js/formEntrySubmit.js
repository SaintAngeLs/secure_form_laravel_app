document.addEventListener('DOMContentLoaded', () => {
    const form = document.querySelector('form');

    if (form) {
        form.addEventListener('submit', async (event) => {
            event.preventDefault();

            const formData = new FormData(form);

            try {
                const response = await fetch('/form/create', {
                    method: 'POST',
                    headers: {
                        'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content'),
                        'Accept': 'application/json',
                    },
                    body: formData,
                });

                const result = await response.json();

                if (response.ok) {
                    showPopup('Success', result.message || 'Form submitted successfully.');
                    form.reset();

                    document.querySelector('#file_id').value = ''; // Clear the file ID

                    if (window.clearDropzone) {
                        window.clearDropzone();
                    }
                } else {
                    const errorMessage = result.error || 'An error occurred while submitting the form.';
                    showPopup('Error', errorMessage);
                }
            } catch (error) {
                showPopup('Error', 'An unexpected error occurred. Please try again later.');
                console.error('Error during form submission:', error);
            }
        });
    }
});

function showPopup(title, message) {
    const popupContainer = document.createElement('div');
    popupContainer.className = 'popup-container';

    popupContainer.innerHTML = `
        <div class="popup">
            <h2>${title}</h2>
            <p>${message}</p>
            <button id="popup-close-btn">Close</button>
        </div>
    `;

    document.body.appendChild(popupContainer);

    const closeBtn = popupContainer.querySelector('#popup-close-btn');
    closeBtn.addEventListener('click', () => {
        document.body.removeChild(popupContainer);
    });
}

const style = document.createElement('style');
style.textContent = `
    .popup-container {
        position: fixed;
        top: 0;
        left: 0;
        width: 100%;
        height: 100%;
        background: rgba(0, 0, 0, 0.6);
        display: flex;
        justify-content: center;
        align-items: center;
        z-index: 9999;
    }

    .popup {
        background: white;
        padding: 20px;
        border-radius: 10px;
        text-align: center;
        box-shadow: 0 4px 6px rgba(0, 0, 0, 0.1);
    }

    .popup h2 {
        margin: 0 0 10px;
    }

    .popup p {
        margin: 0 0 20px;
    }

    .popup button {
        padding: 10px 20px;
        background: #007bff;
        color: white;
        border: none;
        border-radius: 5px;
        cursor: pointer;
    }

    .popup button:hover {
        background: #0056b3;
    }
`;
document.head.appendChild(style);
