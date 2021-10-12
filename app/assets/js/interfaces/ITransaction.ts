import {ICategory} from "./ICategory";
import {ICurrency} from "./ICurrency";
import {IUser} from "./IUser";

export interface ITransaction {
  "@id"?: string;
  id?: string
  name: string;
  value: number;
  description?: string;
  category?: ICategory | string;
  currency: ICurrency | string;
  madeBy?: IUser;
  createDate: string;
}
