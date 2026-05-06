<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
    <title>{{ $scholarshipName }} Application</title>
    <style>
        body {
            font-family: 'Times New Roman', Times, serif;
            font-size: 11pt;
            color: #000;
            line-height: 1.3;
            margin: 0;
            padding: 10px;
        }
        .header {
            text-align: center;
            border-bottom: 2px solid #000;
            padding-bottom: 8px;
            margin-bottom: 15px;
        }
        .header h1 {
            color: #000;
            margin: 0;
            font-size: 16pt;
            text-transform: uppercase;
        }
        .header p {
            margin: 2px 0 0 0;
            font-size: 9pt;
            font-style: italic;
        }
        .section {
            margin-bottom: 15px;
        }
        .section-title {
            border-bottom: 1px solid #000;
            padding: 2px 0;
            font-size: 11pt;
            font-weight: bold;
            margin-bottom: 8px;
            text-transform: uppercase;
        }
        .info-grid {
            width: 100%;
            border-collapse: collapse;
        }
        .info-grid td {
            padding: 3px 0;
            vertical-align: top;
        }
        .label {
            font-weight: bold;
            width: 30%;
        }
        .value {
            width: 70%;
        }
        .results-container {
            width: 100%;
            margin-top: 10px;
        }
        .results-column {
            width: 48%;
            display: inline-block;
            vertical-align: top;
        }
        .results-table {
            width: 100%;
            border-collapse: collapse;
        }
        .results-table th, .results-table td {
            border: 1px solid #000;
            padding: 3px 6px;
            text-align: left;
            font-size: 9pt;
        }
        .results-table th {
            background-color: #f2f2f2;
        }
        .footer {
            margin-top: 15px;
            text-align: center;
            font-size: 8pt;
            border-top: 1px solid #000;
            padding-top: 5px;
        }
    </style>
</head>
<body>
    <div class="header">
        <h1>{{ $scholarshipName }} Application</h1>
        <p>Generated via ScholarshipAdvisor on {{ date('d F Y') }}</p>
    </div>

    <div class="section">
        <div class="section-title">Personal Information</div>
        <table class="info-grid">
            <tr><td class="label">Full Name:</td><td class="value">{{ $user->name }}</td></tr>
            <tr><td class="label">Email Address:</td><td class="value">{{ $user->email }}</td></tr>
            <tr><td class="label">Phone Number:</td><td class="value">{{ $user->phone_num }}</td></tr>
            <tr><td class="label">IC Number:</td><td class="value">{{ $user->ic_number }}</td></tr>
            <tr><td class="label">Address:</td><td class="value">{{ $user->address }}</td></tr>
            <tr><td class="label">Birth State:</td><td class="value">{{ $user->birth_state }}</td></tr>
            <tr><td class="label">Nationality:</td><td class="value">{{ $user->nationality }}</td></tr>
            <tr><td class="label">Gender:</td><td class="value">{{ $user->gender }}</td></tr>
        </table>
    </div>

    @if($qualification)
    <div class="section">
        <div class="section-title">Academic Qualifications</div>
        <table class="info-grid">
            <tr>
                <td class="label">Education Level:</td>
                <td class="value">{{ $qualification->education_level }}</td>
            </tr>
            <tr>
                <td class="label">Field of Study:</td>
                <td class="value">{{ $qualification->field_of_study }}</td>
            </tr>
            <!-- Vertical CGPA Records for better spacing -->
            @foreach(['Diploma' => 'diploma_cgpa', 'STPM' => 'stpm_cgpa', 'Foundation' => 'foundation_cgpa', 'Bachelor' => 'bachelor_cgpa', 'Master' => 'master_cgpa'] as $label => $field)
                @if($qualification->$field)
                    <tr>
                        <td class="label">{{ $label }} CGPA:</td>
                        <td class="value">{{ number_format($qualification->$field, 2) }}</td>
                    </tr>
                @endif
            @endforeach
            @if($qualification->muet_band)
                <tr><td class="label">MUET Band:</td><td class="value">{{ $qualification->muet_band }}</td></tr>
            @endif
            @if($qualification->cefr)
                <tr><td class="label">CEFR Level:</td><td class="value">{{ $qualification->cefr }}</td></tr>
            @endif
        </table>
    </div>

    <div class="results-container">
        <!-- SPM Column -->
        <div class="results-column" style="margin-right: 2%;">
            <div style="font-weight: bold; margin-bottom: 4px; font-size: 9pt; text-transform: uppercase;">SPM Results</div>
            @if($qualification->spm_results && count($qualification->spm_results) > 0)
                <table class="results-table">
                    <thead><tr><th>Subject</th><th style="width: 40px;">Grade</th></tr></thead>
                    <tbody>
                        @foreach($qualification->spm_results as $subject => $grade)
                            <tr><td>{{ $subject }}</td><td>{{ $grade }}</td></tr>
                        @endforeach
                    </tbody>
                </table>
            @endif
        </div>

        <!-- STPM Column -->
        <div class="results-column">
            <div style="font-weight: bold; margin-bottom: 4px; font-size: 9pt; text-transform: uppercase;">STPM Results</div>
            @if($qualification->stpm_results && count($qualification->stpm_results) > 0)
                <table class="results-table">
                    <thead><tr><th>Subject</th><th style="width: 40px;">Grade</th></tr></thead>
                    <tbody>
                        @foreach($qualification->stpm_results as $subject => $grade)
                            <tr><td>{{ $subject }}</td><td>{{ $grade }}</td></tr>
                        @endforeach
                    </tbody>
                </table>
            @endif
        </div>
    </div>
    @endif

    <div class="footer">
        Generated by ScholarshipAdvisor on {{ date('Y-m-d H:i:s') }}
    </div>
</body>
</html>
