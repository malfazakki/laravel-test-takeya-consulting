# Laravel Skill Test

**Home Test Project for Laravel Developer Position at Takeya Consulting**

This is the result of the Home Test given by Takeya Consulting for the Laravel Developer position. All requirements listed in the README.md have been fulfilled and thoroughly tested.

---

## Checklist for README.md Specification Fulfillment

### Drafts and Scheduling
- Posts can be saved as drafts (`is_draft`) or scheduled for future publishing (`published_at`).
- Endpoints filter and distinguish between draft, scheduled, and published posts.

### Scheduled Posts
- Scheduled posts are automatically "published" (appear in index/show) when the `published_at` time has passed, with no manual update required.
- No scheduled post appears before its scheduled time.

### Authentication
- All operations requiring authentication (create, update, delete) use Laravel's session/cookie-based authentication.
- Guests cannot create, edit, or delete posts.

### Specific Routes
- `posts.create` and `posts.edit` may be skipped or simply return a string as instructed.
- No view files, only JSON/redirect responses.

### Testing
- All main routes (index, store, show, update, destroy) have feature tests for both success and failure scenarios.
- Tests cover validation, authorization, and filtering.

### Best Practice
- Follows Laravel 12 best practices (fillable, relationships, casts, etc).

---