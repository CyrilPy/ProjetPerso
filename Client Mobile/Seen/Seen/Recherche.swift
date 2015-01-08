//
//  Recherche.swift
//  Seen
//
//  Created by Cyril Py on 06/01/2015.
//  Copyright (c) 2015 Cyril Py. All rights reserved.
//

import UIKit
import Foundation

class Recherche: UIViewController, UITableViewDelegate, UITableViewDataSource  {
    @IBOutlet weak var tableView: UITableView!
    @IBOutlet weak var sbSearch: UISearchBar!

    var items: NSDictionary!
    var searchText:String!
    
    override func viewDidLoad() {
        super.viewDidLoad()
        
        self.tableView.registerClass(UITableViewCell.self, forCellReuseIdentifier: "cell")
    }
    
    override func didReceiveMemoryWarning() {
        super.didReceiveMemoryWarning()
        // Dispose of any resources that can be recreated.
    }
    
    func searchBarSearchButtonClicked( searchBar: UISearchBar!)
    {
        self.searchText = searchBar.text
        searchBar.resignFirstResponder()
        
        var recherche = self.searchText.stringByReplacingOccurrencesOfString(" ", withString: "%20", options: NSStringCompareOptions.LiteralSearch, range: nil)
        
        self.items = parseJSON(getJSON("http://perso.imerir.com/cpy/Seen/recherche.php?quoi=f&titre=" + recherche))
        dispatch_async(dispatch_get_main_queue(), { () -> Void in
            self.tableView.reloadData()
        })
    }
    
    
    
    func getJSON(urlToRequest: String) -> NSData{
        return NSData(contentsOfURL: NSURL(string: urlToRequest)!)!
    }
    
    func parseJSON(inputData: NSData) -> NSDictionary{
        var error: NSError?
        var json: NSDictionary = NSJSONSerialization.JSONObjectWithData(inputData, options: NSJSONReadingOptions.MutableContainers, error: &error) as NSDictionary
        return json
    }
    
    
    func tableView(tableView: UITableView, numberOfRowsInSection section: Int) -> Int {
        if ((self.items) != nil)  {
            return self.items["film"]!.count;
        } else {
            return 0;
        }
    }
    
    func tableView(tableView: UITableView, cellForRowAtIndexPath indexPath: NSIndexPath) -> UITableViewCell {
        
        var cell:UITableViewCell = self.tableView.dequeueReusableCellWithIdentifier("cell") as UITableViewCell
        
        if let navn = self.items["film"]![indexPath.row]["titre_f"] as? NSString {
            cell.textLabel?.text = navn
        } else {
            cell.textLabel?.text = "No Name"
        }
        
        if let desc = self.items["film"]![indexPath.row]["synopsis_f"] as? NSString {
            cell.detailTextLabel?.text = desc
        }
        return cell
    }
    
    func tableView(tableView: UITableView, didSelectRowAtIndexPath indexPath: NSIndexPath) {
       
        dispatch_async(dispatch_get_main_queue(), {
            let storyboard = UIStoryboard(name: "Main", bundle: nil)
            let vc = storyboard.instantiateViewControllerWithIdentifier("FilmsDetails") as FilmsDetails
            vc.pagePrecedente = "recherche"
            vc.id_bs = self.items["film"]![indexPath.row]["id_bs_f"] as String
            vc.titre = self.items["film"]![indexPath.row]["titre_f"] as String
            vc.titre_original = self.items["film"]![indexPath.row]["titre_original_f"] as String
            vc.date = self.items["film"]![indexPath.row]["date_sortie_f"] as String
            vc.duree = self.items["film"]![indexPath.row]["duree_f"] as String
            vc.langue = self.items["film"]![indexPath.row]["langue_f"] as String
            vc.realisateur = self.items["film"]![indexPath.row]["realisateur_f"] as String
            vc.synopsis = self.items["film"]![indexPath.row]["synopsis_f"] as String
            
            self.presentViewController(vc, animated: true, completion: nil)
        });
    }
    @IBAction func RetourAcceuil(sender: UIBarButtonItem) {
        dispatch_async(dispatch_get_main_queue(), {
            let storyboard = UIStoryboard(name: "Main", bundle: nil)
            let vc = storyboard.instantiateViewControllerWithIdentifier("Acceuil") as Acceuil
            self.presentViewController(vc, animated: true, completion: nil)
        });
    }
}