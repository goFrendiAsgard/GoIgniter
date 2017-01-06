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
        {{ total_tests }} test performed.
        <span class="passed">{{ passed_tests }} passed</span>,
        <span class="failed">
            {% if failed_tests > 0 %}
                <a class="failed" href="#failed">{{ failed_tests }} failed.</a>
            {% else %}
                {{ failed_tests }} failed.
            {% endif %}
        </span>
    </div>

    <h3>Memory usage : {{ memory_usage }}, Total execution time : {{ elapsed_time }} seconds</h3>

    {% if queries | length > 0 %}
        <h3>Queries ({{ total_queries }}), executed in {{ total_query_time | round(4) }}</h3>
        <table class="result-table">
            <tr>
                <th>No</th>
                <th>Execution Time</th>
                <th>SQL</th>
            </tr>
            {% set i = 1 %}
            {% for query in queries %}
                <tr>
                    <td>{{ i }}</td>
                    <td>{{ query.time | round(4) }}</td>
                    <td>{{ query.sql | nl2br }}</td>
                </tr>
                {% set i= i+1 %}
            {% endfor %}
        </table>
    {% endif %}

    <h3>Tests</h3>
    <table class="result-table">
        {% set i = 1 %}
        {% set header = '<tr>
            <th>No</th>
            <th>Test Name</th>
            <th>Location</th>
            <th>Test</th>
            <th>Expected</th>
            <th>Result</th>
            <th>Notes</th>
        </tr>' %}
        {% for row in tests %}
            {% if row.header != '' %}
                <tr><th class="separator" colspan="7">{{ row.header }}</th></tr>
                {{ header | raw }}
            {% endif %}
            <tr>
                <td>{{ i }}
                <td>{{ row.test_name }}</td>
                <td><code>{{ row.file }} : {{ row.line }}</code></td>
                <td><b>{{ row.test_datatype }}</b> <code>{{ row.test }}</code></td>
                <td><b>{{ row.res_datatype }}</b> <code>{{ row.expected }}</code></td>
                <td class="{{ row.result }}">
                    {% if row.result == 'failed' %}
                        <a name="failed"></a>
                    {% endif %}
                    {{ row.result }}
                </td>
                <td>{{ row.notes|nl2br }}</td>
            </tr>
            {% set i = i+1 %}
        {% endfor %}
    </table>

</body>
</html>
