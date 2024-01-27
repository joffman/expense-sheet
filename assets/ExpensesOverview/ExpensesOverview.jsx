import React from "react";
import {ExpenseListElement} from "../ExpenseListElement/ExpenseListElement";

export function ExpensesOverview() {
    const expenses = [
        {
            id: 1,
            date: new Date(),
            name: "Expense 1",
            costs: 25.5,
            paymentSource: "Janosch",
        },
        {
            id: 2,
            date: new Date(),
            name: "Expense 2 with very long name lalalallaa and some more",
            costs: 23.5,
            paymentSource: "Janosch",
        },
        {
            id: 3,
            date: new Date(),
            name: "Expense 3",
            costs: 33,
            paymentSource: "Lamisa",
        },
    ];

    return (
        <div>
            <h1>Expenses Overview</h1>

            <button>Add expense</button>

            {expenses.map(element => (
                <ExpenseListElement key={element.id} expense={element} />
            ))}
        </div>
    );
}