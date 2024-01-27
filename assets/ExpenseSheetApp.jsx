import React from "react";
import {
    BrowserRouter, Route, Routes,
} from "react-router-dom";
import {ExpensesOverview} from "./ExpensesOverview/ExpensesOverview";
import {ExpenseDetails} from "./ExpenseDetails/ExpenseDetails";


export function ExpenseSheetApp() {
    return (
        <div>
            <BrowserRouter>
                <Routes>
                    <Route path={"/expenses?"} element={<ExpensesOverview />}/>
                    <Route path={"expenses/:expenseId"} element={<ExpenseDetails />}/>
                </Routes>
            </BrowserRouter>
        </div>
    );
}