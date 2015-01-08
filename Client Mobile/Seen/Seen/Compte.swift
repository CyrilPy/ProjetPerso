//
//  Compte.swift
//  Seen
//
//  Created by Cyril Py on 06/01/2015.
//  Copyright (c) 2015 Cyril Py. All rights reserved.
//

import UIKit
import Foundation

class Compte: UIViewController, UITableViewDelegate, UITableViewDataSource {
    var items: [String] = ["Déconnexion"]
    @IBOutlet var tableView: UITableView!
    
    override func viewDidLoad() {
        super.viewDidLoad()
        // Do any additional setup after loading the view, typically from a nib.
        self.tableView.registerClass(UITableViewCell.self, forCellReuseIdentifier: "cell")
    }
    
    override func didReceiveMemoryWarning() {
        super.didReceiveMemoryWarning()
        // Dispose of any resources that can be recreated.
    }
    @IBAction func RetourAcceuil(sender: UIBarButtonItem) {
        dispatch_async(dispatch_get_main_queue(), {
            let storyboard = UIStoryboard(name: "Main", bundle: nil)
            let vc = storyboard.instantiateViewControllerWithIdentifier("Acceuil") as Acceuil
            self.presentViewController(vc, animated: true, completion: nil)
        });
    }
    
    func tableView(tableView: UITableView, numberOfRowsInSection section: Int) -> Int {
        
        return self.items.count;
    }
    
    func tableView(tableView: UITableView, cellForRowAtIndexPath indexPath: NSIndexPath) -> UITableViewCell {
        var cell:UITableViewCell = self.tableView.dequeueReusableCellWithIdentifier("cell") as UITableViewCell
        
        cell.textLabel?.text = self.items[indexPath.row]
        
        return cell
    }
    
    func tableView(tableView: UITableView, didSelectRowAtIndexPath indexPath: NSIndexPath) {
        
        switch indexPath.row {
        case 0 :
            dispatch_async(dispatch_get_main_queue(), {
                let url = NSURL(string: "http://perso.imerir.com/cpy/Seen/session.php?action=d")
                let task = NSURLSession.sharedSession().dataTaskWithURL(url!) {(data, response, error) in
                    
                    dispatch_async(dispatch_get_main_queue(), {
                        let storyboard = UIStoryboard(name: "Main", bundle: nil)
                        let vc = storyboard.instantiateViewControllerWithIdentifier("Connexion") as Connexion
                        self.presentViewController(vc, animated: true, completion: nil)
                        });
                }
                task.resume()
                
            });
            break;
                default:
            break;
        }
    }
}

