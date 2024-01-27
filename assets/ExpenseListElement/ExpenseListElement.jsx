import React from "react";
import {formatDate} from "../utils/date-utils/formatDate";

import "./ExpenseListElement.scss"

export function ExpenseListElement({expense}) {

    return (
        <div className={"ExpenseListElement"}>
            <div className={"ExpenseListElement-primaryInfo"}>
                <div className={"ExpenseListElement-date"}>{formatDate(expense.date)}</div>
                <div className={"ExpenseListElement-costs"}>{expense.costs} €</div>
            </div>
            <div className={"ExpenseListElement-secondaryInfo"}>
                <div className={"ExpenseListElement-name"}>{expense.name}</div>
                <div className={"ExpenseListElement-paymentSource"}>{expense.paymentSource}</div>
            </div>
        </div>
    )
}