import React from "react";
import {useParams} from "react-router-dom";

export function ExpenseDetails() {
    const {expenseId} = useParams();

    return (
        <div>
            <h1>Expense Details</h1>
            <p>ID: {expenseId}</p>
        </div>
    );
}