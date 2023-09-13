// Initialization for ES Users
import {
    Datatable,
    initTE,
  } from "tw-elements";
  
  initTE({ Datatable });

const instance = new Datatable(document.getElementById('datatable'))

document.getElementById('datatable-search-input').addEventListener('input', (e) => {
instance.search(e.target.value);
});