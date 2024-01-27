import React from "react";
import {formatDate} from "../utils/date-utils/formatDate";

import "./ExpenseListElement.scss"
import {useNavigate} from "react-router-dom";

export function ExpenseListElement({expense}) {
    const navigate = useNavigate();

    function handleClick() {
        navigate(`/expenses/${expense.id}`)
    }

    return (
        <div
            className={"ExpenseListElement"}
            onClick={handleClick}
        >
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