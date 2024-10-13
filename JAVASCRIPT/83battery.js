let k=0;
let input;
let li = [];
let pricesList = {
    "item811": 6270,
    "item812": 4950,
    "item813": 1950,

    "item821": 2834,
    "item822": 2512,
    "item823": 1815,
    
    "item831": 4600,
    "item832": 4399,
    "item833": 9658,
    "item834": 12349,

    "item841": 700,
    "item842": 1182,
    "item843": 2895,
    "item844": 15000,

    "item851": 900,
    "item852": 500,
    "item853": 249,
    
    "item861": 1099,
    "item862": 599,
    "item863": 299,

    "item871": 2500,
    "item872": 12950,

    "item881": 199,
    "item882": 299,
    "item883": 99,
    "item884": 249,
    "item885": 189,
    "item886": 249,
    "item887": 649,
    "item888": 469,
    "item889": 169
}

let itemsList = {
    "item811": "Front Wind Sheild",
    "item812": "Rear Wind Sheild",
    "item813": "Door Glass",

    "item821": "Front Shock Absorber",
    "item822": "Rear shock absorber",
    "item823": "Lower Arm Replacement",

    "item831": "Amaron Battery",
    "item832": "Exide Battery",
    "item833": "Livguard Battery",
    "item834": "Alternator (Battery)",


    "item841": "Cycle Tyre",
    "item842": "Bike Tyre",
    "item843": "Car Tyre",
    "item844": "Lorry Tyre",

    "item851": "Head Lights",
    "item852": "Signal Lights",
    "item853": "License Plate Lights",

    "item861": "Side Wing Mirror",
    "item862": "Rear View Mirror",
    "item863": "Pull Down Mirror",

    "item871": "Clutch Bearing Replacement",
    "item872": "Flywheel Replacement",

    "item881": "Car Wash Shampoo",
    "item882": "Degreaser",
    "item883": "Glass Cleaner",
    "item884": "Tire Cleaner",
    "item885": "All Purpose Cleaner",
    "item886": "Interior Cleaner",
    "item887": "Bug & Tar Remover",
    "item888": "Leather Conditioner",
    "item889": "Rim Cleaner"
}

function increment(id) {
    input = document.getElementById(id);
    let currentValue = parseInt(input.value);

    // Make sure the value doesn't exceed the max
    if (currentValue < input.max) {
        input.value = currentValue + 1;
        k=input.value;
        updateMainPage();
    }
}

function decrement(id) {
    const input = document.getElementById(id);
    let currentValue = parseInt(input.value);

    // Make sure the value doesn't go below the min
    if (currentValue > input.min) {
        input.value = currentValue - 1;
        k=input.value;
        updateMainPage();        
    }
}

function updateMainPage() {
    let itemIndex = li.findIndex(item => item.key === input.id);
    if (itemIndex !== -1) {
        li[itemIndex].value = k;
    } else {
        li.push({ key: input.id, value: k });
    }
    console.log(`This is List`);
    li.forEach(item => console.log(item));
    window.parent.document.getElementById('pid').innerText = `Selected quantity: ${k}`;
    console.log("Vachindha?");

}

function generateBill(){
    console.log("Generate bill clicked!");
    const tbody = window.parent.document.getElementById('tbody');
    tbody.innerHTML = '';
    let sum=0;
    // Populate the table with updated list
    li.forEach(item => {
        const productName=itemsList[item.key];
        const price = pricesList[item.key];
        const total = item.value * price;
        sum += total;
        const row = window.parent.document.createElement('tr');
        row.innerHTML = `         
            <td class="tdx">${item.key}</td>
            <td class="tdx">${productName}</td>
            <td class="tdx">${item.value}</td>
            <td class="tdx">${price}</td>
            <td class="tdx">${total}</td>
        `;
        tbody.appendChild(row);
    });
    const totalRow = window.parent.document.createElement('tr');
    totalRow.innerHTML = `
        <td colspan="3"></td>
        <td class="tdx"><strong>Total</strong></td>
        <td class="tdx"><strong>${sum}</strong></td>
    `;
    tbody.appendChild(totalRow); // Append the total row to the table

    console.log(`Total bill ${sum}`);
}
