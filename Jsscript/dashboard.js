document.addEventListener('DOMContentLoaded', function() {
    const profilePicture = document.getElementById('profile');
    const options = document.getElementById('options');

    function toggleOptions() {
        options.style.display = options.style.display === 'block' ? 'none' : 'block';
    }

    profilePicture.addEventListener('click', function(e) {
        e.preventDefault();
        toggleOptions();
    });

    document.addEventListener('click', function(e) {
        if (!options.contains(e.target) && e.target !== profilePicture) {
            options.style.display = 'none';
        }
    });

    const notesContainers = document.querySelectorAll('.notes-container');

    notesContainers.forEach((notesContainer) => {
        const setts = notesContainer.querySelectorAll('.setts');
        const optionsMenus = notesContainer.querySelectorAll('.options-menu');

        setts.forEach((settsItem, index) => {
            settsItem.addEventListener('click', function(e) {
                const rect = settsItem.getBoundingClientRect();
                const optionsMenu = optionsMenus[index];
                if (optionsMenu.style.display === 'block') {
                    optionsMenu.style.display = 'none';
                } else {
                    optionsMenu.style.display = 'block';
                    optionsMenu.style.top = rect.bottom + 'px';
                    optionsMenu.style.left = rect.left + 'px';
                }
            });
        });

        document.addEventListener('click', function(e) {
            setts.forEach((settsItem, index) => {
                const optionsMenu = optionsMenus[index];
                if (!settsItem.contains(e.target) && !optionsMenu.contains(e.target)) {
                    optionsMenu.style.display = 'none';
                }
            });
        });
    });

    const modalBox = document.getElementById("modalBox");
    const addNoteButton = document.getElementById("addNoteButton");

    addNoteButton.addEventListener('click', function() {
        overlay.style.display = "block";
        modalBox.style.display = "block";
    });
});

function showEditOverlay() {
    document.getElementById('editOverlay').style.display = 'block';
    document.getElementById('editModalBox').style.display = 'block';
}

function hideEditOverlay() {
    document.getElementById('editOverlay').style.display = 'none';
    document.getElementById('editModalBox').style.display = 'none';
}

function showEditOverlay(noteId) {
    const editOverlay = document.getElementById('editOverlay');
    const editModalBox = document.getElementById('editModalBox');
    
    // Set the value of the hidden input field
    document.getElementById('editNoteId').value = noteId;
    
    // Make AJAX request to fetch note data
    const xhr = new XMLHttpRequest();
    xhr.open('POST', 'getnote.php');
    xhr.setRequestHeader('Content-Type', 'application/x-www-form-urlencoded');
    xhr.onload = function() {
        if (xhr.status === 200) {
            const response = JSON.parse(xhr.responseText);
            if (response.error) {
                console.error(response.error);
            } else {
                // Populate form fields with retrieved data
                document.getElementById('editFormTitle').value = response.note_title;
                document.getElementById('editDescription').value = response.note_desc;
                
                // Show edit overlay and modal box
                editOverlay.style.display = 'block';
                editModalBox.style.display = 'block';
            }
        } else {
            console.error('Failed to fetch note data');
        }
    };
    xhr.send('note_id=' + noteId);
}