export interface ApiResponse {
    code: number,
    data: any,
    message: string
}

export interface ConferenceData {
    action:string,
    year: number,
    startDate: string,
    endDate: string,
    venue: string,
    theme: string,
    aboutConference: string,
    defaultFee: number,
    foreignerFee:number,
    guestFee: number,
}
// export interface UserDataArray extends Array<User> {}

export interface User {
    id:number,
    firstName: string,
    middleName: string,
    lastName: string,
    email:string,

}
export interface  SpeakerData {
    id: string,
    name:string,
    email:string,
    designation:string,
    institution:string,
    linkedinLink:string,
    twitterLink:string,
    isMain:string,
    conference_id:string,
    imageFileName:string,
    is_visible:boolean
}
export interface Credential {
    email:string,
    password:string,
}
export interface LoggedUser{
    id:number,
    firstName:string,
    middleName:string,
    lastName:string,
    token:string,
    email:string,
    email_verified_at:string,
    created_at:string,
    updated_at:string,
    message:string
}
export interface RegistrationInfo {
    firstName: string,
    middleName: string,
    lastName: string,
    email: string,
    password: string;
    password_confirmation: string;
}
