<!DOCTYPE html>
<html>

<head>
    <meta charset="utf-8">
    <title>Print Transaction</title>
    <style>
        body {
            font-family: Arial, sans-serif;
        }

        h1 {
            text-align: center;
            margin-bottom: 20px;
        }

        table {
            width: 100%;
            border-collapse: collapse;
            margin-bottom: 20px;
        }

        th,
        td {
            border: 1px solid #ddd;
            padding: 8px;
            text-align: left;
        }

        th {
            background-color: #f2f2f2;
        }

        @media print {
            h1 {
                margin: 0;
                font-size: 24px;
            }

            table {
                margin-bottom: 10px;
                font-size: 16px;
            }

            th,
            td {
                padding: 5px;
                font-size: 14px;
            }

            .print-button {
                display: none;
            }
        }
    </style>
</head>

<body>
    <h1>Transaction Details</h1>
    <table>
        <thead>
            <tr>
                <th>Owner Name</th>
                <th>Employee Name</th>
                <th>Service Type</th>
                <th>Price</th>
                <th>Transaction Method</th>
                <th>Transaction Date</th>
            </tr>
        </thead>
        <tbody>
            <tr>
                <td>{{ $transaction->petOwner->first_name }} {{ $transaction->petOwner->last_name }}</td>
                <td>{{ $transaction->employee->first_name }} {{ $transaction->employee->last_name }}</td>
                <td>{{ $transaction->servicePrice->serviceType->service_name }}</td>
                <td>{{ $transaction->servicePrice->price }}</td>
                <td>{{ $transaction->transactionMethod->transaction_type }}</td>
                <td>{{ $transaction->transaction_date }}</td>
            </tr>
        </tbody>
    </table>
    <script>
        window.onload = function() {
            window.print();
        };
    </script>
</body>

</html>
