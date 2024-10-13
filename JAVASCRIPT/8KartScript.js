
    function showItems(page) {
        // Target the division where the HTML should be loaded
        const container = document.querySelector('.KartcategoriesItems');
        const defaultText = document.getElementById('defaultText');

        // Remove the placeholder text if it exists
        if (defaultText) {
            defaultText.style.display = 'none';
        }

        // Load the selected HTML content into the division
        fetch(page)
            .then(response => response.text())
            .then(data => {
                container.innerHTML = data;
            })
            .catch(error => {
                console.error('Error loading page:', error);
                container.innerHTML = '<h2>Error loading content. Please try again.</h2>';
            });
    }

