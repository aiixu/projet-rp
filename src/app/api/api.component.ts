import { Component, OnInit } from '@angular/core';

import CreateUserJson from 'src/assets/json/api/users/createUser.json';
import DeleteUserJson from 'src/assets/json/api/users/deleteUser.json';
import GetUserJson from 'src/assets/json/api/users/getUser.json';

@Component({
  selector: 'app-api',
  templateUrl: './api.component.html',
  styleUrls: ['./api.component.css']
})

export class ApiComponent implements OnInit {
  tabSpaces: number = 2;

  items: Array<any> = [
    CreateUserJson,
    DeleteUserJson,
    GetUserJson
  ];

  constructor() {}

  ngOnInit(): void {
  }

  formatRaw(obj: NonNullable<any>, indentLevel: number = 1, isSubObject: boolean = false, isLastObject: boolean = true): string {
    // calculate space count for a single tab, and space count for a curly bracket too
    const tab: string = " ".repeat(this.tabSpaces * indentLevel);
    const cbTab: string = " ".repeat(this.tabSpaces * (indentLevel - 1));

    // if the passed object is a sub object, no need to indent the opening curly bracket
    let result: string = `${isSubObject ? "" : cbTab}{\n`;

    // get the last key of the passed object
    const lastKey = Object.keys(obj)[Object.keys(obj).length - 1];

    // iterate over each item of obj
    for(const key in obj)
    {
      // store value corresponding to key in object, and check if it's the last key
      const value = obj[key];
      const valueType = value.type;
      const isLastKey = key == lastKey;

      // add key to result with the right indentation
      result += `${tab}"${value.optional ? `[${key}]` : key}": `;

      // if the value is an object, format it too
      if (typeof valueType == "object" && valueType !== null)
      {
        // by adding a new indentation level, by saying that the object is a sub object
        // the function needs to know if the passed object is the last one too
        result += this.formatRaw(valueType, indentLevel + 1, true, isLastKey) + "\n";
      }
      else
      {
        // add value to the current line, and if it's not the last key, add a comma, otherwhise, nothing
        result += valueType + `${isLastKey ? "" : ","}\n`;
      }
    }

    // return the result with closing curly bracket, with a trailling comma if the current object isn't the last one in the parent object
    return result + `${cbTab}}${isLastObject ? "" : ","}`;
  }

  formatTable(obj: NonNullable<any>, path: string = ""): Array<any> {
    let result: Array<any> = [];

    for(const key in obj)
    {
      const value = obj[key];
      const valueType = value.type;

      if (typeof valueType == "object" && valueType !== null)
      {        
        result = result.concat(this.formatTable(value.type, key));
      }
      else
      {
        result.push({
          name: `${path !== "" ? `${path}.${key}` : key}`,
          type: valueType,
          optional: value.optional ? "Oui" : "Non",
          description: value.description
        });
      }
    }
    
    return result;
  }

  formatAxios(obj: NonNullable<any>, indentLevel: number = 1, isSubObject: boolean = false, isLastObject: boolean = true): string {
    const tab: string = " ".repeat(this.tabSpaces * indentLevel);
    const cbTab: string = " ".repeat(this.tabSpaces * (indentLevel - 1));

    let result: string = !isSubObject ? "const request: any = {\n" : cbTab + "{\n";
    
    const lastKey = Object.keys(obj)[Object.keys(obj).length - 1];

    for(const key in obj)
    {
       const value = obj[key];
      const valueType = value.type;
      const isLastKey = key == lastKey;

      result += `${tab}${value.optional ? `[${key}]` : key}: `;

      if (typeof valueType == "object" && valueType !== null)
      {
       result += this.formatRaw(valueType, indentLevel + 1, true, isLastKey) + "\n";
      }
      else
      {
        if(typeof(value.example) == typeof("")) value.example = `"${value.example}"`;
        result += value.example + `${isLastKey ? "" : ","}\n`;
      }
    }

    result += `${cbTab}}${isLastObject ? "" : ","}`;

    if(isLastObject)
    {
      result += `\n\naxios.${obj.method}(`;
    }
    
    return result;
  }
}
