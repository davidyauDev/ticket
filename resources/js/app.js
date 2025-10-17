import flatpickr from "flatpickr";
import "flatpickr/dist/flatpickr.min.css";

// Inicializar
flatpickr("#datepicker", {
    defaultDate: new Date(),
    dateFormat: "Y-m-d",
});