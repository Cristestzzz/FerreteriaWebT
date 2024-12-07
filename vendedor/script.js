// Datos simulados de productos
const productos = [
    { nombre: "Martillo", precio: 25 },
    { nombre: "Destornillador", precio: 15 },
    { nombre: "Taladro", precio: 120 },
];

// Cargar productos en la lista
const listaProductos = document.getElementById("lista-productos");
productos.forEach((producto) => {
    const item = document.createElement("li");
    item.textContent = `${producto.nombre} - $${producto.precio}`;
    listaProductos.appendChild(item);
});

// Manejar formulario de ventas
const formVenta = document.getElementById("form-venta");
formVenta.addEventListener("submit", (e) => {
    e.preventDefault();
    const producto = document.getElementById("producto").value;
    const cantidad = parseInt(document.getElementById("cantidad").value);

    alert(`Venta registrada: ${cantidad} x ${producto}`);
    formVenta.reset();
});
