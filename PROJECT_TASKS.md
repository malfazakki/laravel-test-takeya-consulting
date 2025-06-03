# Laravel Skill Test - Project Tasks

## Project Setup and Preparation
### Environment Configuration
- [x] Clone repository
- [x] Set up environment file
- [x] Install dependencies
- [x] Generate application key
- [x] Configure database connection

### Authentication Setup
- [ ] Implement user registration
- [ ] Implement user login
- [ ] Set up authentication middleware
- [ ] Create authentication controllers/methods

## Post Model and Routes Implementation
### Post Model Enhancements
- [ ] Review existing Post model
- [ ] Add scopes for:
  - [ ] Active posts
  - [ ] Draft posts
  - [ ] Scheduled posts
- [ ] Implement relationship with User model

### Route Implementation
#### posts.index Route
- [ ] Implement pagination (20 per page)
- [ ] Include user data
- [ ] Filter out drafts and scheduled posts
- [ ] Create JSON response

#### posts.create Route
- [ ] Create placeholder or minimal implementation

#### posts.store Route
- [ ] Add authentication check
- [ ] Implement validation
- [ ] Create post creation logic
- [ ] Handle draft and scheduled posts

#### posts.show Route
- [ ] Implement single post retrieval
- [ ] Create JSON response
- [ ] Add 404 for draft/scheduled posts

#### posts.edit Route
- [ ] Create placeholder or minimal implementation

#### posts.update Route
- [ ] Implement author authorization
- [ ] Add validation
- [ ] Create update logic

#### posts.destroy Route
- [ ] Implement author authorization
- [ ] Create delete post functionality

### Scheduled Post Publishing
- [ ] Create command to publish scheduled posts
- [ ] Set up scheduler
- [ ] Implement automatic publishing mechanism

## Testing
### Feature Tests
#### posts.index Tests
- [ ] Verify pagination
- [ ] Confirm active posts only
- [ ] Check user data inclusion

#### posts.store Tests
- [ ] Test authenticated user creation
- [ ] Validate input checks
- [ ] Test draft and scheduled post handling

#### posts.show Tests
- [ ] Test successful retrieval
- [ ] Verify 404 for draft/scheduled posts

#### posts.update Tests
- [ ] Check author update permissions
- [ ] Validate update inputs

#### posts.destroy Tests
- [ ] Verify author delete permissions

## Code Quality and Best Practices
- [ ] Follow Laravel 12 documentation
- [ ] Implement proper error handling
- [ ] Use meaningful commit messages
- [ ] Ensure code follows Laravel conventions

## Documentation
- [ ] Update README with project setup instructions
- [ ] Add comments for complex logic
- [ ] Document custom implementations

## Final Checks
- [ ] Run all tests
- [ ] Perform code quality review
- [ ] Verify all requirements are met

## Deployment
- [ ] Prepare for deployment
- [ ] Final system testing
- [ ] Push to public repository 
