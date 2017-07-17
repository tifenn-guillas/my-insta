import { Component } from '@angular/core';

import { Image } from './image.model';
import { AddImageService } from './add-image.service';

@Component({
  selector: 'app-add-image',
  templateUrl: './add-image.component.html',
  styleUrls: ['./add-image.component.css']
})
export class AddImageComponent {
  image: Image = {id: null, description: null, tags: null, file: null};

  constructor(private addImageService: AddImageService) { }

  fileChangeEvent(fileInput: any){
    this.image.file = fileInput.target.files[0];
  }

  submit() {
    this.addImageService.getImages().subscribe(
        response => console.log('ok'),
        error => console.error(error)
    );
      console.log(this.image);
  }

}
