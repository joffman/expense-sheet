import React from "react";
import {
    BrowserRouter, Link, Route, Routes,
} from "react-router-dom";


export function ExpenseSheetApp() {
    return (
        <div>
            <h1>Expense Sheet</h1>
            <p>More to come</p>
            <BrowserRouter>
                <Routes>
                    <Route path={"/expenses?"} element={<div>Index page <Link to={"expenses"}>Go to expenses</Link></div>}/>
                    <Route path={"expenses/:expenseId"} element={<div>Single Expense</div>}/>
                </Routes>
            </BrowserRouter>
        </div>
    );
}