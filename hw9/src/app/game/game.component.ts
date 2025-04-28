import { Component } from '@angular/core';
import { FormsModule } from '@angular/forms';
import { CommonModule } from '@angular/common';
import { HttpClient } from '@angular/common/http'; // provided by main.ts

@Component({
  selector: 'app-game',
  standalone: true,
  imports: [FormsModule, CommonModule],
  templateUrl: './game.component.html',
  styleUrls: ['./game.component.css']
})
export class GameComponent {
  word: string = 'example';
  guesses: number = 0;
  guessWord: string = '';
  guessedWord: string = '';
  lss: string[] = [];
  positions: number = 0; 
  targetchars: number = 0; 

  constructor(private http: HttpClient) {
    this.fetchWord(); 
  }

  onGuessChange(newGuess: string): void {
    console.log('Guess changed:', newGuess); 
  }

  onGuessSubmit(): void {
    this.guesses++; 
    this.updateGuessWord();
    this.guessWord = ''; 
  }

  updateGuessWord(): void {
    this.guessedWord = this.guessWord; 
    this.checkWord(); 
    console.log('Guessed word:', this.guessedWord); 
  };

  fetchWord(): void {
    // http://localhost:8080/project/angular.php (returns json {"word":"example"})
    this.http.get<{ word: string }>('http://localhost:8080/project/angular.php')
      .subscribe({
        "next": (data) => {
          this.word = data.word; 
          console.log('Fetched word:', this.word); 
        },
        "error": (error) => {
          console.error('Error fetching word:', error); 
        } 
      });
  }

  checkWord(): void {
    this.positions = 0; 
    this.targetchars = 0; 
    this.lss = []; 

    if (this.guessedWord.length < this.word.length) {
      this.lss.push('longer'); 
    } else if (this.guessedWord.length > this.word.length) {
      this.lss.push('shorter'); 
    } else {
      this.lss.push('same length'); 
    }

    // Some more information about the guessed word
    if (this.guessedWord.length < this.word.length * 2) {
      this.lss.push('shorter than double');
    } else if (this.guessedWord.length > this.word.length * 2) {
      this.lss.push('longer than double');
    }

    // Assumes that targetchars should only increment unique characters
    for (let i = 0; i < Math.min(this.word.length, this.guessedWord.length); i++) {
      if (this.word[i] === this.guessedWord[i]) {
        this.positions++; 
      } else if (this.word.includes(this.guessedWord[i])) {
        this.targetchars++; 
      }
    }
  }


}
