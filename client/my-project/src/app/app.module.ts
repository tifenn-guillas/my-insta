import { BrowserModule } from '@angular/platform-browser';
import { NgModule } from '@angular/core';
import { FormsModule } from '@angular/forms';
import { HttpModule } from '@angular/http';

import { AppRoutingModule } from './app.routing.module';

import { ConfigService } from './core/config.service';
import { AppComponent } from './app.component';
import { HomeComponent } from './home/home.component';
import { AddImageComponent } from './add-image/add-image.component';
import { AddImageService } from './add-image/add-image.service';

@NgModule({
  declarations: [
    AppComponent,
    HomeComponent,
    AddImageComponent],
  imports: [
    BrowserModule,
    FormsModule,
    HttpModule,
    AppRoutingModule
  ],
  providers: [ConfigService, AddImageService],
  bootstrap: [AppComponent]
})
export class AppModule { }
