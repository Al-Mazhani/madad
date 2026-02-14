class Book {
    #Titile;
    #Page;
    #Author;
    #Category;
    #URLPDF;
    #URLImage;
    constructor(Title, Page, Author, Category, URLPDF, URLImage) {
        this.#Titile = Title;
        this.#Page = Page;
        this.#Author = Author;
        this.#Category = Category;
        this.#URLPDF = URLPDF;
        this.#URLImage = URLImage;
    }
    get GetName() {
        return this.#Titile;
    }
    get GetPage() {
        return this.#Page;
    }
    get GetAuthor() {
        return this.#Author;
    }
    get GetCategory() {
        return this.#Category;
    }
    get GetPDF() {
        return this.#URLPDF;
    }
    get GetImage() {
        return this.#URLImage;
    }
    set SetName(Name) {
        this.#Titile = Name;
    }
    set SetPage(Page) {
        this.#Page = Page;
    }
    set SetAuthor(Author) {
        this.#Author = Author;
    }
    set SetCategory(Category) {
        this.#Category = Category;
    }
    set SetPDF(PDF) {
        this.#URLPDF = PDF;
    }
    set SetImage(Image) {
        this.#URLImage = Image;
    }

}
let books = [];

books.push(new Book(
    "JavaScript Basics",
    300,
    "Ali",
    "Programming",
    "js.pdf",
    "js.jpg"
));

books.push(new Book(
    "OOP Guide",
    250,
    "Sara",
    "Programming",
    "oop.pdf",
    "oop.jpg"
));

books.push(new Book(
    "HTML & CSS",
    200,
    "Omar",
    "Web",
    "html.pdf",
    "html.jpg"
));

for (let i = 0; i < books.length; i++) {
    console.log("Title:", books[i].GetName);
    console.log("Pages:", books[i].GetPage);
    console.log("Author:", books[i].GetAuthor);
    console.log("------------------");
}
