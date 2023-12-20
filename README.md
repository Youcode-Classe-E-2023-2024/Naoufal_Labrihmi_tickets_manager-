# Naoufal_Labrihmi_tickets_manager-
# Kanban for Developers

## Introduction
Kanban for Developers is a web application designed to facilitate task management and collaboration among developers. The site is built using Bootstrap, PHP, and Ajax for a seamless user experience.

## Features

### Task Management
- **Task Sections:** The Kanban board consists of three sections: `All Tasks`, `Doing`, and `Done`. Developers can move tasks between these sections based on their progress.
- **Task Details:** Each task includes the following details:
  - Title
  - Description
  - Created By
  - Created At
  - Priority
  - Tags

### Authentication
- **Login:** Developers can log in to their accounts securely.
- **Logout:** Users can log out to secure their sessions.
- **Register:** New developers can register to create an account.

### Task Assignment
- **Assigned To Me:** Developers can view tasks assigned to them.
- **Created By Me:** Users can see tasks created by them.

### Comments and Replies
- **Commenting:** Developers can leave comments on tasks to discuss details.
- **Reply:** Replies can be added to existing comments for threaded discussions.
- **Timestamps:** All comments and replies include timestamps for reference.

## Database Schema

### Tables
1. `comments`
   - Fields: `id`, `task_id`, `comment_text`, `posted_by`, `created_at`, `has_replies`

2. `comment_replies`
   - Fields: `id`, `comment_id`, `reply_text`, `replied_by`, `created_at`

3. `developers`
   - Fields: `id`, `name`, `email`, `username`, `password`

4. `priorities`
   - Fields: `id`, `name`

5. `tags`
   - Fields: `id`, `name`

6. `todo`
   - Fields: `id`, `title`, `description`, `created_at`, `status`, `priority_id`, `created_by`

7. `todo_developers`
   - Fields: `id`, `todo_id`, `developer_id`

8. `todo_tags`
   - Fields: `id`, `todo_id`, `tag_id`

### Relationships
- Foreign key relationships link tables for data consistency.
- Examples:
  - `comments.task_id` links to `todo.id`
  - `comments.posted_by` links to `developers.id`

## Technologies Used
- **Frontend:** Bootstrap for a responsive and visually appealing interface.
- **Backend:** PHP for server-side scripting.
- **Asynchronous Requests:** Ajax for seamless and fast interactions.

## Database
- **SQL:** The database is built using SQL, with tables for tasks, developers, priorities, tags, comments, and more.

## Conclusion
Kanban for Developers provides an efficient way for developers to manage tasks, collaborate through comments, and track progress on the Kanban board.

**Note:** Ensure to secure sensitive information, such as passwords and database credentials, in a production environment.
