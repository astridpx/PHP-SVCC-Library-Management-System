let wrapperCard = document.querySelector(".wrapper-card");
let students = document.querySelector(".student-card");
let issueBook = document.querySelector(".issue-book-card");
let allRecords = document.querySelector(".return-books-card");
let books = document.querySelector(".book-card");

// student card link
students.addEventListener("click", () => {
  // console.log("hello");
  window.location.href = "student-records.php";
});

issueBook.addEventListener("click", () => {
  // console.log("hello");
  window.location.href = "issue-book.php";
});

allRecords.addEventListener("click", () => {
  window.location.href = "return-book.php";
});

books.addEventListener("click", () => {
  window.location.href = "books.php";
});
