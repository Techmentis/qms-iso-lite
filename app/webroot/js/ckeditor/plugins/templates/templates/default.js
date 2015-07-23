/*
 Copyright (c) 2003-2013, CKSource - Frederico Knabben. All rights reserved.
 For licensing, see LICENSE.md or http://ckeditor.com/license
*/
CKEDITOR.addTemplates("default",{
    imagesPath:CKEDITOR.getUrl(CKEDITOR.plugins.getPath("templates")+"templates/images/"),
    templates:[
               {title:"Header Template",
               image:"template1.gif",
               description:"Use this style for header",
               html:'<table cellspacing="2" cellpadding="2" width="100%" border="0">'+
                    '<tr><td colspan="4"><h2><a href=" <FlinkISO> company_details-Company-name </FlinkISO> " class="badge label-info add-margin"> Your Company Name </a></h2>Powered by : FlinkISO </td> </tr>'+
                    '<tr><td>Document Title </td><td>&nbsp;<a href=" <FlinkISO> MasterListOfFormat-title </FlinkISO> " class="badge label-info add-margin">Title</a></td>'+
		    '<td>Document Number</td><td>&nbsp;<a href=" <FlinkISO> MasterListOfFormat-document_number </FlinkISO> " class="badge label-info add-margin">'+
                    'Document Number</a></td> </tr> <tr> <td>Revision Number </td><td>&nbsp;<a href=" <FlinkISO> MasterListOfFormat-revision_number </FlinkISO> " class="badge label-info add-margin">Revision Number</a></td> <td>Revision Date</td><td>&nbsp;<a href=" <FlinkISO> MasterListOfFormat-revision_date </FlinkISO> " class="badge label-info add-margin">Revision Date</a></td> </tr> <tr> <td>Issue Number </td><td>&nbsp;<a href=" <FlinkISO> MasterListOfFormat-issue_number </FlinkISO> " class="badge label-info add-margin">Issue Number</a></td> <td>Issue Date</td><td>&nbsp;<a href=" <FlinkISO> MasterListOfFormat-issue_date </FlinkISO> " class="badge label-info add-margin">Issue Date</a></td> </tr> </tbody></table> '},
               
    {title:"1 Column - Multiple Records Template",
               image:"template2.gif",
               description:"Choose this template for any report with will have 1 column.",
               html:'<table cellspacing="2" cellpadding="2" width="100%" border="0">'+
               '<tr valign="static"><th>Heading One</th></tr>'+
               
               '<tr flink="loop"><td>Drop fields here</td></tr>'+
               '</table>'},
    {title:"2 Column - Multiple Records Template",
               image:"template2.gif",
               description:"Choose this template for any report with will 2 columns.",
               html:'<table cellspacing="2" cellpadding="2" width="100%" border="0">'+
               
               '<tr valign="static"><th>Heading One</th><th>Heading Two</th></tr>'+
               '<tr loop><td>Drop fields here</td><td>Drop fields here</td></tr>'+
               '</table>'},
    {title:"3 Column - Multiple Records Template",
               image:"template2.gif",
               description:"Choose this template for any report with will have 3 columns.",
               html:'<table cellspacing="2" cellpadding="2" width="100%" border="0">'+
               
               '<tr><div><th>Heading One</th><th>Heading Two</th><th>Heading Three</th></tr>'+
               '<tr><td>Drop fields here</td><td>Drop fields here</td><td>Drop fields here</td></div></tr>'+
               '</table>'},
    {title:"4 Column - Multiple Records Template",
               image:"template2.gif",
               description:"Choose this template for any report with will have 4 columns.",
               html:'<table cellspacing="2" cellpadding="2" width="100%" border="0">'+
               
               '<tr><th>Heading One</th><th>Heading Two</th><th>Heading Three</th><th>Heading Four</th></tr>'+
               '<tr class="loop"><td>Drop fields here</td><td>Drop fields here</td><td>Drop fields here</td><td>Drop fields here</td></tr>'+
               '</table>'},
    {title:"5 Column - Multiple Records Template",
               image:"template2.gif",
               description:"Choose this template for any report with will have 5 columns.",
               html:'<table cellspacing="2" cellpadding="2" width="100%" border="0">'+
               
               '<tr><th>Heading One</th><th>Heading Two</th><th>Heading Three</th><th>Heading Four</th><th>Heading Five</th></tr>'+
               '<tr><td>Drop fields here</td><td>Drop fields here</td><td>Drop fields here</td><td>Drop fields here</td><td>Drop fields here</td></tr>'+
               '</table>'},
    {title:"6 Column - Multiple Records Template",
               image:"template2.gif",
               description:"Choose this template for any report with will have 6 columns.",
               html:'<table cellspacing="2" cellpadding="2" width="100%" border="0">'+
               
               '<tr><th>Heading One</th><th>Heading Two</th><th>Heading Three</th><th>Heading Four</th><th>Heading Five</th><th>Heading Six</th></tr>'+
               '<tr><td>Drop fields here</td><td>Drop fields here</td><td>Drop fields here</td><td>Drop fields here</td><td>Drop fields here</td><td>Drop fields here</td></tr>'+
               '</table>'},
    {title:"7 Column - Multiple Records Template",
               image:"template2.gif",
               description:"Choose this template for any report with will have 7 columns.",
               html:'<table cellspacing="2" cellpadding="2" width="100%" border="0">'+
               
               '<tr><th>Heading One</th><th>Heading Two</th><th>Heading Three</th><th>Heading Four</th><th>Heading Five</th><th>Heading Six</th><th>Heading Seven</th></tr>'+
               '<tr><td>Drop fields here</td><td>Drop fields here</td><td>Drop fields here</td><td>Drop fields here</td><td>Drop fields here</td><td>Drop fields here</td></tr>'+
               '</table>'},
    {title:"8 Column - Multiple Records Template",               
               image:"template2.gif",
               description:"Choose this template for any report with will have 8 columns.",
               html:'<table cellspacing="2" cellpadding="2" width="100%" border="0">'+
               
               '<tr><th>Heading One</th><th>Heading Two</th><th>Heading Three</th><th>Heading Four</th><th>Heading Five</th><th>Heading Six</th><th>Heading Seven</th><th>Heading Eight</th></tr>'+
               '<tr><td>Drop fields here</td><td>Drop fields here</td><td>Drop fields here</td><td>Drop fields here</td><td>Drop fields here</td><td>Drop fields here</td><td>Drop fields here</td><td>Drop fields here</td></tr>'+
               '</table>'},
    {title:"9 Column - Multiple Records Template",
               image:"template2.gif",
               description:"Choose this template for any report with will have eight 9 columns.",
               html:'<table cellspacing="2" cellpadding="2" width="100%" border="0">'+
               
               '<tr><th>Heading One</th><th>Heading Two</th><th>Heading Three</th><th>Heading Four</th><th>Heading Five</th><th>Heading Six</th><th>Heading Seven</th><th>Heading Eight</th><th>Heading Nine</th></tr>'+
               '<tr><td>Drop fields here</td><td>Drop fields here</td><td>Drop fields here</td><td>Drop fields here</td><td>Drop fields here</td><td>Drop fields here</td><td>Drop fields here</td><td>Drop fields here</td><td>Drop fields here</td></tr>'+
               '</table>'},
    {title:"10 Column - Multiple Records Template",
               image:"template2.gif",
               description:"Choose this template for any report with will have nine 10 columns.",
               html:'<table cellspacing="2" cellpadding="2" width="100%" border="0">'+
               
               '<tr><th>Heading One</th><th>Heading Two</th><th>Heading Three</th><th>Heading Four</th><th>Heading Five</th><th>Heading Six</th><th>Heading Seven</th><th>Heading Eight</th><th>Heading Nine</th><th>Heading Ten</th></tr>'+
               '<tr><td>Drop fields here</td><td>Drop fields here</td><td>Drop fields here</td><td>Drop fields here</td><td>Drop fields here</td><td>Drop fields here</td><td>Drop fields here</td><td>Drop fields here</td><td>Drop fields here</td><td>Drop fields here</td></tr>'+
               '</table>'},
            {title:"Single Record Template",
            image:"template3.gif",
            description:"A title with some text and a table.",
            html:'<table cellspacing="2" cellpadding="2" width="100%" border="0"><tr><td>&nbsp;create your layout</td></tr></table>'},
            {title:"Footer Template",
            image:"template1.gif",
            description:"Use this style for footer",
            html:'<h3><table width="100%" border="1"><tr><td>Document Number</td><td> </td><td>Issue</td><td> </td></tr><tr><td>Issue Date</td><td> </td><td>Issue Numner</td><td> </td></tr><tr><td>Prepared By</td><td> </td><td>Approved By</td><td> </td></tr>'},
            ]});