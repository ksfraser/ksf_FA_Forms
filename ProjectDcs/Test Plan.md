# ksf_FA_Forms - Test Plan Document

**Document Version:** 1.0  
**Date:** May 13, 2026  
**Module:** FA_Forms (FrontAccounting Form Builder)  
**Status:** Approved

---

## 1. Introduction

### 1.1 Purpose

Comprehensive testing strategy for the FA_Forms module.

### 1.2 Test Environment

| Component | Version |
|-----------|---------|
| FrontAccounting | 2.4+ |
| PHP | 7.3+ |
| MySQL | 5.7+ |
| PHPUnit | 9.x |

---

## 2. Test Scenarios

### 2.1 Form Management Tests

**TC-FRM-001: Create Form Success**
```
Test ID: TC-FRM-001
Title: Create new form with all field types
Priority: Critical

Test Steps:
1. Create form with name: "Test Form"
2. Add fields: text, email, select, textarea
3. Save form

Pass Criteria: Form created with ID
```

**TC-FRM-002: Create Form Duplicate Name**
```
Test ID: TC-FRM-002
Title: Reject duplicate form names
Priority: High

Test Steps:
1. Create form "Contact Form"
2. Try to create another "Contact Form"

Pass Criteria: Error message shown
```

**TC-FRM-003: Edit Form**
```
Test ID: TC-FRM-003
Title: Modify form fields
Priority: High

Test Steps:
1. Select existing form
2. Add new field
3. Remove optional field
4. Save

Pass Criteria: Changes persisted
```

**TC-FRM-004: Delete Form**
```
Test ID: TC-FRM-004
Title: Delete form removes submissions
Priority: High

Test Steps:
1. Create form with submissions
2. Delete form
3. Verify form and submissions removed

Pass Criteria: CASCADE delete works
```

---

### 2.2 Field Validation Tests

**TC-FRM-005: Text Field Validation**
```
Test ID: TC-FRM-005
Title: Text field required validation
Priority: High

Test Steps:
1. Create form with required text field
2. Submit without filling field
3. Verify error shown

Pass Criteria: Required validation works
```

**TC-FRM-006: Email Field Validation**
```
Test ID: TC-FRM-006
Title: Email format validation
Priority: Critical

Test Data:
- Valid: test@example.com
- Invalid: notanemail, @nodomain, test@

Test Steps:
1. Submit form with valid email
2. Verify success
3. Submit form with invalid email
4. Verify error

Pass Criteria: Valid formats accepted, invalid rejected
```

**TC-FRM-007: Phone Field Validation**
```
Test ID: TC-FRM-007
Title: Phone format acceptance
Priority: High

Test Data:
- 555-123-4567
- (555) 123-4567
- +1 5551234567
- 5551234567

Pass Criteria: All valid phone formats accepted
```

**TC-FRM-008: Select Field Validation**
```
Test ID: TC-FRM-008
Title: Select field options validation
Priority: High

Test Steps:
1. Create form with select field
2. Options: [A, B, C]
3. Submit with option B selected
4. Verify B stored

Pass Criteria: Select value stored correctly
```

**TC-FRM-009: Required Select Validation**
```
Test ID: TC-FRM-009
Title: Required select must have value
Priority: High

Test Steps:
1. Create form with required select
2. Submit without selecting option
3. Verify error

Pass Criteria: Required select validated
```

---

### 2.3 Submission Tests

**TC-FRM-010: Submit Valid Form**
```
Test ID: TC-FRM-010
Title: Submit form with valid data
Priority: Critical

Test Steps:
1. Create active form
2. Submit with all fields filled correctly
3. Verify submission stored
4. Verify success message

Pass Criteria: Submission created
```

**TC-FRM-011: Submit Inactive Form**
```
Test ID: TC-FRM-011
Title: Reject submission to inactive form
Priority: High

Test Steps:
1. Create form in inactive status
2. Attempt to submit

Pass Criteria: Error message shown
```

**TC-FRM-012: Multiple Submissions**
```
Test ID: TC-FRM-012
Title: Multiple submissions from same user
Priority: Medium

Test Steps:
1. Submit form once
2. Submit form again with different data
3. Verify both stored
4. Verify both linked to form

Pass Criteria: Multiple submissions work
```

---

### 2.4 CRM Integration Tests

**TC-FRM-013: Auto Link by Email**
```
Test ID: TC-FRM-013
Title: Submission auto-linked to customer by email
Priority: High

Test Data:
- Customer exists with email: customer@example.com

Test Steps:
1. Submit form with email: customer@example.com
2. Verify debtor_no populated

Pass Criteria: Customer linked automatically
```

**TC-FRM-014: View Customer Submissions**
```
Test ID: TC-FRM-014
Title: View all submissions for customer
Priority: Medium

Test Steps:
1. Customer has 3 submissions
2. View customer submission history
3. Verify all 3 shown

Pass Criteria: Complete history displayed
```

---

### 2.5 Export Tests

**TC-FRM-015: Export Submissions CSV**
```
Test ID: TC-FRM-015
Title: Export submissions to CSV
Priority: Medium

Test Steps:
1. Create form with submissions
2. Export to CSV
3. Open CSV file
4. Verify data matches

Pass Criteria: CSV accurate and complete
```

---

## 3. Test Data

### 3.1 Forms

| Name | Fields | Status |
|------|--------|--------|
| Contact Form | name, email, message | active |
| Survey | rating, feedback | active |
| Support Request | subject, description, priority | inactive |

### 3.2 Submissions

| Form | Submitter | Email |
|------|-----------|-------|
| Contact Form | John Doe | john@example.com |
| Contact Form | Jane Smith | jane@example.com |
| Survey | Bob Wilson | bob@example.com |

---

## 4. Pass Criteria

| Test Type | Pass Rate |
|-----------|-----------|
| Unit Tests | 100% |
| Integration Tests | 100% |
| System Tests | 100% |

---

## 5. Test Deliverables

1. Test cases (this document)
2. Test execution report
3. Code coverage report
4. Bug reports