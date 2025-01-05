document.addEventListener('DOMContentLoaded', () => {
    const form = document.querySelector('#form-entry');

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
                    showPopup('Success', result.message || 'Form submitted successfully.', 'success');

                    form.reset();
                    document.querySelector('#file_id').value = '';

                    if (window.clearDropzone) {
                        window.clearDropzone();
                    }
                } else {
                    const errorMessage = result.error || 'An error occurred while submitting the form.';
                    showPopup('Error', errorMessage, 'error');
                }
            } catch (error) {
                showPopup('Error', 'An unexpected error occurred. Please try again later.', 'error');
                console.error('Error during form submission:', error);
            }
        });
    }
});

function showPopup(title, message, type) {
    const popupContainer = document.createElement('div');
    popupContainer.className = `popup-container ${type}`;

    popupContainer.innerHTML = `
        <div class="popup">
            <h2 class="popup-title">${title}</h2>
            <p class="popup-message">${message}</p>
            <button id="popup-close-btn" class="popup-button">Close</button>
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
        animation: fadeIn 0.3s ease;
    }

    .popup {
        background: white;
        padding: 20px;
        border-radius: 10px;
        text-align: center;
        box-shadow: 0 4px 6px rgba(0, 0, 0, 0.1);
        max-width: 400px;
        width: 90%;
    }

    .popup-title {
        font-size: 1.5rem;
        margin-bottom: 10px;
    }

    .popup-message {
        font-size: 1rem;
        margin-bottom: 20px;
    }

    .popup-button {
        padding: 10px 20px;
        background: #007bff;
        color: white;
        border: none;
        border-radius: 5px;
        cursor: pointer;
        transition: background-color 0.3s ease;
    }

    .popup-button:hover {
        background: #0056b3;
    }

    .popup-container.success .popup {
        border-left: 5px solid #28a745;
    }

    .popup-container.error .popup {
        border-left: 5px solid #dc3545;
    }

    @keyframes fadeIn {
        from {
            opacity: 0;
        }
        to {
            opacity: 1;
        }
    }
`;
document.head.appendChild(style);
