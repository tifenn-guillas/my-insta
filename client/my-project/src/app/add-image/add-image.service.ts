import { Injectable } from '@angular/core';
import { Http, Response, Headers, RequestOptions } from '@angular/http';

import { ConfigService } from '../core/config.service';
import { Image } from './image.model';

@Injectable()
export class AddImageService {
  private addImageUrl = this.config.apiUrl + '/images'; //TODO: Change URL

  constructor(
    private http: Http,
    private config: ConfigService
  ) { }

  addImage(image: Image) {
    // const headers = new Headers({ 'Content-Type': 'application/json' });
    // const options = new RequestOptions({ headers: headers });
    // const body = JSON.stringify(image);
    // return this.http.post(this.addImageUrl, body, options)
    //   .map((res: Response) => res.json());
  }
}
