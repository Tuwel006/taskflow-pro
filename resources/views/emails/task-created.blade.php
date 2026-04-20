<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>New Task Assigned</title>
    <style>
        body {
            font-family: 'Inter', -apple-system, BlinkMacSystemFont, 'Segoe UI', Roboto, sans-serif;
            background-color: #f8fafc;
            margin: 0;
            padding: 0;
            width: 100% !important;
        }
        .wrapper {
            width: 100%;
            table-layout: fixed;
            background-color: #f8fafc;
            padding-bottom: 40px;
        }
        .main {
            background-color: #ffffff;
            margin: 0 auto;
            width: 100%;
            max-width: 600px;
            border-spacing: 0;
            color: #1e293b;
            border-radius: 12px;
            overflow: hidden;
            box-shadow: 0 4px 6px -1px rgba(0, 0, 0, 0.1);
        }
        .header {
            background-color: #0f172a;
            padding: 30px;
            text-align: center;
        }
        .content {
            padding: 40px 30px;
        }
        h1 {
            font-size: 24px;
            font-weight: 700;
            margin-bottom: 20px;
            color: #0f172a;
            letter-spacing: -0.02em;
        }
        p {
            font-size: 16px;
            line-height: 1.6;
            margin-bottom: 20px;
            color: #475569;
        }
        .task-card {
            background-color: #f1f5f9;
            border-radius: 8px;
            padding: 20px;
            margin-bottom: 30px;
        }
        .task-label {
            font-size: 12px;
            font-weight: 700;
            color: #64748b;
            text-transform: uppercase;
            letter-spacing: 0.05em;
            margin-bottom: 4px;
        }
        .task-value {
            font-size: 16px;
            font-weight: 600;
            color: #0f172a;
            margin-bottom: 16px;
        }
        .btn {
            display: inline-block;
            background-color: #3b82f6;
            color: #ffffff !important;
            padding: 14px 28px;
            font-size: 16px;
            font-weight: 600;
            text-decoration: none;
            border-radius: 8px;
            text-align: center;
        }
        .footer {
            padding: 30px;
            text-align: center;
            font-size: 14px;
            color: #94a3b8;
        }
        .priority-badge {
            display: inline-block;
            padding: 4px 10px;
            border-radius: 9999px;
            font-size: 12px;
            font-weight: 700;
            background-color: #e2e8f0;
            color: #475569;
        }
    </style>
</head>
<body>
    <div class="wrapper">
        <center>
            <table class="main" width="100%">
                <tr>
                    <td class="header">
                        <img src="https://cdn-icons-png.flaticon.com/512/9534/9534484.png" alt="TaskFlow" width="48" style="margin-bottom: 10px;">
                        <div style="color: #ffffff; font-size: 20px; font-weight: 700; letter-spacing: 0.05em;">TASKFLOW PRO</div>
                    </td>
                </tr>
                <tr>
                    <td class="content">
                        <h1>New Task Assigned</h1>
                        <p>Hello {{ $name }},</p>
                        <p>You have been assigned a new task in the <strong>TaskFlow</strong> registry. Please review the details below:</p>
                        
                        <div class="task-card">
                            <div class="task-label">Task Title</div>
                            <div class="task-value">{{ $taskTitle }}</div>
                            
                            <table width="100%">
                                <tr>
                                    <td width="50%">
                                        <div class="task-label">Priority</div>
                                        <div class="task-value">{{ $taskPriority }}</div>
                                    </td>
                                    <td width="50%">
                                        <div class="task-label">Due Date</div>
                                        <div class="task-value">{{ $taskDueDate }}</div>
                                    </td>
                                </tr>
                            </table>
                            
                            @if($taskDescription)
                                <div class="task-label">Description</div>
                                <div style="font-size: 14px; color: #475569; line-height: 1.5;">{{ $taskDescription }}</div>
                            @endif
                        </div>
                        
                        <center>
                            <a href="{{ $url }}" class="btn">View Task Detail</a>
                        </center>
                    </td>
                </tr>
                <tr>
                    <td class="footer">
                        <p style="margin-bottom: 10px;">&copy; {{ date('Y') }} TaskFlow Pro. All rights reserved.</p>
                        <p style="font-size: 12px;">This is an automated system notification. Please do not reply to this email.</p>
                    </td>
                </tr>
            </table>
        </center>
    </div>
</body>
</html>
