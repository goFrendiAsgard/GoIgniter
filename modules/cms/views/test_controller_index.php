<!DOCTYPE html>
<html>
<head>
    <style>
        body
        {
            font-family: arial;
            padding-top: 50px;
            padding-bottom: 50px;
        }
        code
        {
            font-size: smaller;
            font-family: monospace, courier;
        }
        .passed
        {
            color:#0C0;
        }
        .failed
        {
            color:#C00;
        }
        .summary
        {
            padding-top: 10px;
            padding-bottom: 10px;
            height: 30px;
            position: fixed;
            top: 0;
            width: 100%;
            background-color: #EEE;
            border-bottom: 1px solid #CCC;
        }
        .result-table
        {
            width: 100%;
        }
        .result-table th, .result-table td
        {
            border: 1px solid #CCC;
            font-size: small;
            padding-left: 5px;
            padding-right: 5px;
        }
        .result-table th.separator
        {
            padding-top: 20px;
            font-size: initial;
            text-align: left;
            border: none;
        }
    </style>
</head>
<body>
    <div class="summary">
        {{ total }} test performed.
        <span class="passed">{{ passed }} passed</span>,
        <span class="failed">{{ failed }} failed.</span>
    </div>

    <h3>Tests</h3>
    <table class="result-table">
        {% set header = '<tr>
            <th>Test Name</th>
            <th>Location</th>
            <th>Test</th>
            <th>Expected</th>
            <th>Result</th>
            <th>Notes</th>
        </tr>' %}
        {% for row in result %}
            {% if row.header != '' %}
                <tr><th class="separator" colspan="6">{{ row.header }}</th></tr>
                {{ header | raw }}
            {% endif %}
            <tr>
            <td> {{ row.test_name }}</td>
            <td><code>{{ row.file }} : {{ row.line }}</code></td>
            <td><b>{{ row.test_datatype }}</b> <code>{{ row.test }}</code></td>
            <td><b>{{ row.res_datatype }}</b> <code>{{ row.expected }}</code></td>
            <td class="{{ row.result }}">{{ row.result }}</td>
            <td>{{ row.notes|nl2br }}</td>
            </tr>
        {% endfor %}
    </table>

    {% if queries | length > 0 %}
        <h3>Queries ({{ total_queries }}), executed in {{ total_query_time }}</h3>
        <table class="result-table">
            <tr>
                <th>Execution Time</th>
                <th>SQL</th>
            </tr>
            {% for query in queries %}
                <tr>
                    <td>{{ query.time }}</td>
                    <td>{{ query.sql | nl2br }}</td>
                </tr>
            {% endfor %}
        </table>
    {% endif %}

</body>
</html>
