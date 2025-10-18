// This function runs when the entire HTML document has been loaded and parsed.
document.addEventListener('DOMContentLoaded', function () {

    // A function to load HTML from a file into a placeholder element.
    const loadComponent = (filePath, placeholderId) => {
        const placeholder = document.getElementById(placeholderId);

        if (!placeholder) {
            console.error(`Error: The placeholder element with ID '${placeholderId}' was not found in your HTML file.`);
            return;
        }

        fetch(filePath)
            .then(response => {
                if (!response.ok) {
                    throw new Error(`Network response was not ok. Status: ${response.status} (${response.statusText})`);
                }
                return response.text();
            })
            .then(html => {
                placeholder.innerHTML = html;
            })
            .catch(error => {
                console.error(`Failed to fetch component from '${filePath}':`, error);
                placeholder.innerHTML = `<p style="color: red; text-align: center;">Error: Could not load ${filePath}.</p>`;
            });
    };

    // Load header and footer
    loadComponent('header.html', 'header-placeholder');
    loadComponent('footer.html', 'footer-placeholder');

    // Initialize UI listeners
    initUI();
});


// ------------------------------------------
// Global Variables
// ------------------------------------------

let mealsData = [];
let totalCalories = 0;
let protein = 0;
let carbs = 0;
let fats = 0;

// ------------------------------------------
// UI Initializer
// ------------------------------------------

function initUI() {
    // Show meal popup
    document.querySelector('.cta-button').addEventListener('click', () => {
        document.getElementById('meal-popup').classList.remove('hidden');
    });

    // Close popup
    document.getElementById('close-popup').addEventListener('click', () => {
        document.getElementById('meal-popup').classList.add('hidden');
    });

    // Search meal input
    document.getElementById('meal-search').addEventListener('input', function () {
        const query = this.value.toLowerCase();
        const filtered = mealsData.filter(meal => meal.name.toLowerCase().includes(query));
        displayMeals(filtered);
    });

    // Fetch meals
    fetch('meals.json')
        .then(response => response.json())
        .then(data => {
            mealsData = data;
            displayMeals(data);
        });
}

// ------------------------------------------
// Display Meal List in Popup
// ------------------------------------------

function displayMeals(meals) {
    const list = document.getElementById('meal-list');
    list.innerHTML = '';
    meals.forEach(meal => {
        const li = document.createElement('li');
        li.textContent = `${meal.name} - ${meal.calories} kcal`;
        li.addEventListener('click', () => addMealToSummary(meal));
        list.appendChild(li);
    });
}

// ------------------------------------------
// Add Meal to Summary (with Quantity)
// ------------------------------------------

function addMealToSummary(meal) {
    const quantityInput = document.getElementById('meal-quantity');
    let quantity = parseFloat(quantityInput?.value || '1');

    if (isNaN(quantity) || quantity <= 0) quantity = 1;

    // Update totals
    totalCalories += meal.calories * quantity;
    protein += meal.protein * quantity;
    carbs += meal.carbs * quantity;
    fats += meal.fats * quantity;

    // Update meal list
    const mealList = document.getElementById('todays-meals-list');
    const li = document.createElement('li');
    li.classList.add('meal-item');
    li.innerHTML = `
        <span class="meal-name">${meal.name} x ${quantity}</span>
        <span class="meal-calories">${Math.round(meal.calories * quantity)} kcal</span>
    `;
    mealList.appendChild(li);

    updateUI();

    // Close popup and reset
    document.getElementById('meal-popup').classList.add('hidden');
    quantityInput.value = 1;
}

// ------------------------------------------
// Update Summary UI
// ------------------------------------------

function updateUI() {
    const calorieText = document.querySelector('.calories-text');
    const progressFill = document.querySelector('.progress-bar-fill');
    const proteinElem = document.querySelector('.macro-item:nth-child(1) p');
    const carbsElem = document.querySelector('.macro-item:nth-child(2) p');
    const fatsElem = document.querySelector('.macro-item:nth-child(3) p');

    calorieText.innerHTML = `${Math.round(totalCalories)} <span>/ 2000 kcal</span>`;
    progressFill.style.width = `${Math.min((totalCalories / 2000) * 100, 100)}%`;

    proteinElem.textContent = `${Math.round(protein)}g`;
    carbsElem.textContent = `${Math.round(carbs)}g`;
    fatsElem.textContent = `${Math.round(fats)}g`;
}
