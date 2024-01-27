/*
 * Welcome to your app's main JavaScript file!
 *
 * We recommend including the built version of this JavaScript file
 * (and its CSS file) in your base layout (base.html.twig).
 */

import React from "react";
import {createRoot} from "react-dom/client";
import {ExpenseSheetApp} from "./ExpenseSheetApp";

// any CSS you import will output into a single css file (app.css in this case)
import './styles/app.css';

const domNode = document.getElementById("expense-sheet-app");
const root = createRoot(domNode);

root.render(<ExpenseSheetApp />)