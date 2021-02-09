import { ComponentFixture, TestBed } from '@angular/core/testing';

import { ViewRpComponent } from './view-rp.component';

describe('ViewRpComponent', () => {
  let component: ViewRpComponent;
  let fixture: ComponentFixture<ViewRpComponent>;

  beforeEach(async () => {
    await TestBed.configureTestingModule({
      declarations: [ ViewRpComponent ]
    })
    .compileComponents();
  });

  beforeEach(() => {
    fixture = TestBed.createComponent(ViewRpComponent);
    component = fixture.componentInstance;
    fixture.detectChanges();
  });

  it('should create', () => {
    expect(component).toBeTruthy();
  });
});
